# Polls App

docker build -t vicradon/pollsapp .

curl --location 'http://localhost:8000/api/login' \
--header 'Content-Type: application/json' \
--data-raw '{
"email": "admin@polls-app.com",
"password": "password"
}'
