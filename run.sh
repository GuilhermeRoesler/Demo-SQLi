#!/usr/bin/env bash
set -e
cd "$(dirname "$0")"

if ! command -v php >/dev/null 2>&1; then
  echo "PHP nao encontrado no PATH."
  echo "Instale o PHP (com PDO SQLite) e tente novamente."
  exit 1
fi

echo
echo "Laboratorio SQLi — http://localhost:8000"
echo "Se for a primeira vez, abra tambem: http://localhost:8000/setup.php"
echo "Pressione Ctrl+C para parar o servidor."
echo

abrir_navegador() {
  sleep 1
  if command -v xdg-open >/dev/null 2>&1; then
    xdg-open "http://localhost:8000/index.html" >/dev/null 2>&1 || true
  elif command -v open >/dev/null 2>&1; then
    open "http://localhost:8000/index.html" >/dev/null 2>&1 || true
  fi
}

abrir_navegador &
php -S localhost:8000
