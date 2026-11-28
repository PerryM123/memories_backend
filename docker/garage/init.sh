#!/usr/bin/env bash
# Make a Garage bucket publicly readable (website mode). Idempotent.
#
# The layout, bucket and access key are created by the container itself
# (`garage server --single-node --default-bucket`, Garage v2.3.0+).
# The one thing that flag does NOT do is expose the bucket publicly,
# which is what this script does.
#
# Usage: docker/garage/init.sh [bucket] [compose-file]
#   docker/garage/init.sh                                  # local-bucket, docker-compose.yml
#   docker/garage/init.sh e2e-bucket docker-compose.e2e.yml
set -euo pipefail

BUCKET="${1:-local-bucket}"
COMPOSE_FILE="${2:-docker-compose.yml}"
G=(docker compose -f "$COMPOSE_FILE" exec -T garage /garage)

echo "Waiting for Garage..."
for _ in $(seq 1 30); do
  "${G[@]}" status >/dev/null 2>&1 && break
  sleep 1
done
"${G[@]}" status >/dev/null

echo "Allowing public website access on '$BUCKET'..."
"${G[@]}" bucket website --allow "$BUCKET"
"${G[@]}" bucket info "$BUCKET"
