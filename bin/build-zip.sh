#!/usr/bin/env bash
#
# build-zip.sh — Empacota o tema Acesso U.Porto num .zip distribuível.
#
# Copia APENAS os ficheiros necessários para o tema funcionar (exclui git,
# ficheiros de desenvolvimento, editor, dados de origem em CSV, etc.) e gera:
#
#     wp-content/dist/acesso-uporto-2026-<versão>.zip
#
# (fora da pasta do tema, para os artefactos de build não sujarem o repo).
#
# A <versão> é lida do cabeçalho "Version:" do style.css. O zip contém uma
# pasta de topo "acesso-uporto-2026/", tal como o Theme_Upgrader do WordPress
# precisa em "Aparência → Temas → Carregar tema" e na página própria do tema
# "Ferramentas → Atualizar Tema".
#
# NOTA: nunca inclui .git — instalar/atualizar a partir deste zip não deixa
# um .git no destino que bloqueie o próximo update.
#
# Uso:
#     ./bin/build-zip.sh            # usa a versão do style.css
#     ./bin/build-zip.sh 1.2.0      # força um número de versão (não altera o style.css)
#
set -euo pipefail

SLUG="acesso-uporto-2026"

# Raiz do tema = pasta-mãe deste script (funciona a partir de qualquer diretório).
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
THEME_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"
cd "$THEME_DIR"

# Versão: 1.º argumento, senão o cabeçalho do style.css.
VERSION="${1:-}"
if [[ -z "$VERSION" ]]; then
  VERSION="$(sed -n -E 's/^[[:space:]]*\*?[[:space:]]*Version:[[:space:]]*(.+[^[:space:]])[[:space:]]*$/\1/p' style.css | head -n1)"
fi
if [[ -z "$VERSION" ]]; then
  echo "ERRO: não consegui determinar a versão (nem argumento nem 'Version:' no style.css)." >&2
  exit 1
fi

# Saída fora do tema: wp-content/dist (THEME_DIR = wp-content/themes/<slug>).
DIST_DIR="$(cd "$THEME_DIR/../.." && pwd)/dist"
BUILD_DIR="$(mktemp -d)"
STAGE="$BUILD_DIR/$SLUG"
ZIP_PATH="$DIST_DIR/${SLUG}-${VERSION}.zip"
trap 'rm -rf "$BUILD_DIR"' EXIT

mkdir -p "$STAGE" "$DIST_DIR"

# Exclusões: tudo o que NÃO é preciso para o tema correr em produção.
# (Padrões sem barra à frente aplicam-se a qualquer nível; com barra, só à raiz.)
EXCLUDES=(
  ".git"            # controlo de versões — nunca vai no pacote
  "/.github"        # workflows de CI
  "/.gitattributes"
  "/.gitignore"
  "/.vscode"        # config do editor
  "/.claude"        # config/memória do Claude Code
  "/bin"            # este script e utilitários de build
  "/dist"           # zips já gerados
  "node_modules"
  "*.csv"           # dados de origem do importador (não são precisos em runtime)
  ".DS_Store"
  "Thumbs.db"
  "*.swp"
  "*.log"
  "*.zip"
  "/*.jpg"          # screenshots temporários deixados na raiz
  "/*.jpeg"
  "/*.png"
)

RSYNC_ARGS=(-a)
for e in "${EXCLUDES[@]}"; do
  RSYNC_ARGS+=(--exclude "$e")
done

rsync "${RSYNC_ARGS[@]}" "$THEME_DIR"/ "$STAGE"/

# Ficheiros mínimos que TÊM de existir no pacote (falha cedo se faltar algum).
for required in style.css functions.php theme.json index.php; do
  if [[ ! -f "$STAGE/$required" ]]; then
    echo "ERRO: o pacote ficou sem '$required'." >&2
    exit 1
  fi
done

# Gerar o zip (pasta de topo = slug do tema; -X remove metadados extra).
rm -f "$ZIP_PATH"
( cd "$BUILD_DIR" && zip -rqX "$ZIP_PATH" "$SLUG" )

# Verificação: nada de desenvolvimento pode ter entrado.
if unzip -l "$ZIP_PATH" | grep -Eiq '(^|/)\.git|(^|/)\.vscode|(^|/)\.github|(^|/)\.claude|\.csv$|node_modules'; then
  echo "AVISO: o zip contém ficheiros que deviam ter sido excluídos:" >&2
  unzip -l "$ZIP_PATH" | grep -Ei '(^|/)\.git|(^|/)\.vscode|(^|/)\.github|(^|/)\.claude|\.csv$|node_modules' >&2
  exit 1
fi

FILES="$(unzip -l "$ZIP_PATH" | tail -1 | awk '{print $2}')"
SIZE="$(du -h "$ZIP_PATH" | cut -f1)"
echo "✔ Pacote criado"
echo "   Ficheiro : $ZIP_PATH"
echo "   Versão   : $VERSION"
echo "   Ficheiros: $FILES"
echo "   Tamanho  : $SIZE"
