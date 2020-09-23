# Photos Exchanger 

## Start development with docker

First off, go to `/docker` directory:
```bash
cd docker
```
Copy file `.env.example` into `.env`:
```bash
cp .env.example .env
```
View and edit (if needed) environment `.env` file:

```bash
nano .env
```
> Take heed of local ports configuration. Those have to be available on your machine to run project.

After configuration docker environment file, let's configure  `.env` of laravel:
```bash
cp ../.env.example ../.env
nano ../.env
```

Build docker-compose:
```bash
docker-compose build --no-cache
```

Run docker-compose services:
```bash
docker-compose up -d
```

Connect to php container:
```bash
docker-compose exec php bash
```

Setup development environment (it is located in `docker/services/php/`):
```bash
cd docker/services/php/
bash dev-setup.sh
exit
```

After all, try out `127.0.0.1:8000` (or with another port you configured) in your browser.
