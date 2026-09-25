#!/usr/bin/env sh
set -eu

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
