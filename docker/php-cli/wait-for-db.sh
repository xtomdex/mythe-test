#!/bin/sh
set -e

host="$1"
port=3306

echo "Waiting for database connection at $host..."
until nc -z "$host" "$port"; do
    echo "Database is not ready yet..."
    sleep 2
done

echo "Database is ready"