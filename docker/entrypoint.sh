#!/usr/bin/env sh
set -eu

web_port="${PORT:-8080}"
sed -i "s/__PORT__/${web_port}/g" /etc/apache2/sites-available/000-default.conf

attempt=1
until php spark migrate --all; do
    if [ "$attempt" -ge 12 ]; then
        echo "Database did not become ready after $attempt attempts." >&2
        exit 1
    fi

    echo "Database is not ready; retrying migration in 5 seconds..." >&2
    attempt=$((attempt + 1))
    sleep 5
done

php spark db:seed DatabaseSeeder

exec "$@"
