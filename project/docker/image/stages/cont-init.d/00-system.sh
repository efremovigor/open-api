#!/bin/bash
set -e
# Setting hostname of the host
ip route | awk '/default/ { print $3"    containerhost" }' >> /etc/hosts
echo '172.17.0.1 project.ru' >> /etc/hosts
echo '172.17.0.1 project.alfa' >> /etc/hosts