# Use official PHP Apache image
FROM php:8.1-apache

# Install Python3, pip, and utilities
RUN apt-get update && \
    apt-get install -y python3 python3-pip curl unzip && \
    ln -s /usr/bin/python3 /usr/bin/python && \
    apt-get clean

# Install Python pymongo package
RUN pip3 install pymongo

# Default MongoDB URI (Override this at runtime using -e MONGO_URI="..." in docker run)
ENV MONGO_URI="mongodb://user:pass@host.docker.internal:27017/?authMechanism=DEFAULT"

# Copy PHP APIs folder (includes pythonScripts)
COPY phpApis /var/www/html/phpApis

# Expose port 80
EXPOSE 80

# The php:8.1-apache base image already configures the CMD to run Apache in the foreground
