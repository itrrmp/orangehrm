Instalar dependencias do orangeHRM localmente:

./src folder:
	composer install --no-suggest
	(If needed) -> composer update
	
installer/client folder:
	yarn install
	yarn build / yarn dev
	
src/client folder:
	yarn install
	yarn build / yarn dev
	
Se der erros de prettier (formatação e eslint), executar comando:
	yarn eslint --fix src/
	
Nos 3 ficheiros .prettier adicionar a linha: 
	endOfLine: 'auto'

Docker:

    docker-compose run -d --build   