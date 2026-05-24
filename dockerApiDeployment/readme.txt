Docker Commands for Apache Container
1. Build the Docker Image
docker build -t apache_python_container .


-t apache_docker_container → Assigns a tag (name) to your image.

. → Current directory containing the Dockerfile.

General syntax:

docker build -t <image_name:tag> <path_to_dockerfile>


Notes:

Image names must be lowercase.

Tag is optional (default is latest if omitted).

2. Run the Docker Container
docker run -d -p 8080:80 --name apache_in_docker_container apache_python_container


-d → Run container in detached mode.

-p 8080:80 → Map host port 8080 to container port 80.

--name apache_in_docker_container → Assign a name to the running container.

apache_docker_container → Image name to use for the container.

General syntax:

docker run [options] <image_name>

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



check container running:
http://localhost:8080/phpApis/mongoFetcher/mongoDataFetcher.php?envName=test&dbName=tested1&colName=hers_reports&fnc=find&qry={%22wlId%22:46,%22custId%22:45747984}

for sandboxes:
change this: "mongoDb = "mongodb://<username>:<password>@host.docker.internal:27017/?authMechanism=DEFAULT""
to this: "mongoDb = "mongodb://<username>:<password>@<your_mongo_domain>:27017/?authMechanism=DEFAULT&replicaSet=rs1&directConnection=true"" or your server name



other check commands:
cd /var/www/html/phpApis/mongoFetcher
python3 pythonScripts/mongodb_query_V2.py test tested1 hers_reports find '{"wlId":46,"custId":45747984}'

if this works then everything works:
python pythonScripts/mongodb_query_V2.py test tested1 hers_reports find '{"wlId":46,"custId":45747984}'


