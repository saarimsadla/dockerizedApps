Docker Commands for Apache Container

for https container:
1. docker build -t apache_ssl_python_mongo . 
2. docker run -d -p 80:80 -p 443:443 --name apache_python_ssl_container apache_ssl_python_mongo

3. Useful Docker Commands

List running containers:

docker ps


Stop a container:

docker stop apache_in_docker_container


Remove a container:

docker rm apache_in_docker_container


Remove an image:

docker rmi apache_docker_container


Access container shell:

docker exec -it apache_in_docker_container bash



check container:
use this link to get data:
https://localhost/phpApis/mongoFetcher/mongoDataFetcher.php?envName=test&dbName=tested1&colName=hers_reports&fnc=find&qry={%22wlId%22:46,%22custId%22:45747984}

other check commands:
cd /var/www/html/phpApis/mongoFetcher
python3 pythonScripts/mongodb_query_V2.py test tested1 hers_reports find '{"wlId":46,"custId":45747984}'

if this works then everything works:
python pythonScripts/mongodb_query_V2.py test tested1 hers_reports find '{"wlId":46,"custId":45747984}'


