#!/bin/bash
set -e
# Setting hostname of the host
ip route | awk '/default/ { print $3"    containerhost" }' >> /etc/hosts