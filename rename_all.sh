#!/usr/bin/env bash
set -euo pipefail

# ==== SAFETY ====
# Aus dem Projektroot starten (prüfen wir kurz)
test -f artisan || { echo "Bitte im Projektroot ausführen (artisan nicht gefunden)."; exit 1; }

# Nichts in vendor/, node_modules/, storage/ anfassen
EXCLUDES='-path ./vendor -prune -o -path ./node_modules -prune -o -path ./storage -prune -o'

echo "Snapshot vor Rename…"
git add -A && git commit -m "snapshot: before mass rename" || true

# ==== 1) Dateinamen/Ordner umbenennen ====
echo "Rename von Dateien & Ordnern…"

# Models/Controller/Factories
# Article -> Event
eval "find . $EXCLUDES -type f -name '*Article*' -print0" | while IFS= read -r -d '' f; do
  nf="${f//Article/Event}"
  mkdir -p "$(dirname "$nf")"
  git mv -f "$f" "$nf"
done
# Comment -> Review
eval "find . $EXCLUDES -type f -name '*Comment*' -print0" | while IFS= read -r -d '' f; do
  nf="${f//Comment/Review}"
  mkdir -p "$(dirname "$nf")"
  git mv -f "$f" "$nf"
done
# Author -> Host (Controller, Views-Ordner etc.)
eval "find . $EXCLUDES -type f -name '*Author*' -print0" | while IFS= read -r -d '' f; do
  nf="${f//Author/Host}"
  mkdir -p "$(dirname "$nf")"
  git mv -f "$f" "$nf"
done

# View-Ordner
if [ -d resources/views/articles ]; then git mv resources/views/articles resources/views/events; fi
if [ -d resources/views/authors ];  then git mv resources/views/authors  resources/views/hosts;  fi
if [ -d resources/views/management/articles ]; then
  mkdir -p resources/views/management
  git mv resources/views/management/articles resources/views/management/events
fi

# ==== 2) Inhalte in allen Dateien ersetzen ====
echo "Ersetze Inhalte… (dies dauert kurz)"

# Hilfsfunktion sed für macOS (BSD sed)
sedi() { sed -i '' "$@"; }

# Wir gehen vorsichtig in der Reihenfolge von spezifisch -> generisch vor.
# Nur in sinnvollen Quelldirs suchen:
FILES=$(eval "find . $EXCLUDES -type f \( -name '*.php' -o -name '*.blade.php' -o -name '*.js' -o -name '*.css' -o -name '*.json' -o -name '*.md' -o -name '*.yml' -o -name '*.xml' \)")

# 2a) Klassen/Modelle/Controller (PascalCase)
# Article => Event, Comment => Review, Author => Host
for f in $FILES; do
  sedi 's/\bArticle\b/Event/g' "$f"
  sedi 's/\bComment\b/Review/g' "$f"
  sedi 's/\bAuthor\b/Host/g'    "$f"
done

# 2b) Lowercase-Bezeichner (Variablen, Routen, Blade)
for f in $FILES; do
  # plural & singular
  sedi 's/articles/events/g' "$f"
  sedi 's/comments/reviews/g' "$f"
  sedi 's/authors/hosts/g'    "$f"

  sedi 's/article/event/g' "$f"
  sedi 's/comment/review/g' "$f"
  sedi 's/author/host/g'   "$f"

  # Foreign Key
  sedi 's/author_id/host_id/g' "$f"
done

# 2c) Tabellen in Migrationen anpassen
for f in $(eval "find database/migrations $EXCLUDES -type f -name '*.php'"); do
  # Tabellen-Namen
  sedi 's/\barticles\b/events/g' "$f"
  sedi 's/\bcomments\b/reviews/g' "$f"
done

# ==== 3) Migrations-Dateinamen sinnvoll anpassen (optional) ====
# Nur falls gewünscht – reine Kosmetik. Die Klassen sind anonym, der Dateiname darf abweichen.
if ls database/migrations/*create_articles_table.php >/dev/null 2>&1; then
  for f in database/migrations/*create_articles_table.php; do git mv "$f" "${f//articles/events}"; done
fi
if ls database/migrations/*create_comments_table.php >/dev/null 2>&1; then
  for f in database/migrations/*create_comments_table.php; do git mv "$f" "${f//comments/reviews}"; done
fi

# ==== 4) Autoloader neu und Cache clear ====
composer dump-autoload -q || true
php artisan optimize:clear || true

echo "Rename fertig. Committe Änderungen…"
git add -A
git commit -m "chore: mass rename Article->Event, Comment->Review, Author->Host (+ *_id)"

echo "✅ Alles umbenannt. Nächste Schritte:"
echo "1) Prüfe routes/web.php und Header-Links (events/hosts)."
echo "2) php artisan migrate:fresh --seed"
echo "3) php artisan serve (oder Herd öffnen) & testen."
