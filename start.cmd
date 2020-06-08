@echo off

docker run -it --rm -p 3000:3000 -v %cd%:/app --workdir=/app node:14 bash -c "npm i && npm run dev"

