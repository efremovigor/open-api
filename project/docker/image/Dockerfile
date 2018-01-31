# Pull base image
FROM ubuntu:16.04

# Set the locale
RUN apt-get clean && apt-get update --fix-missing
RUN apt-get install locales
RUN locale-gen en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

# Install s6-overlay
ADD https://github.com/just-containers/s6-overlay/releases/download/v1.18.1.5/s6-overlay-amd64.tar.gz /tmp/
RUN tar xzf /tmp/s6-overlay-amd64.tar.gz -C /

# Upgrading image and base tools
RUN \
    apt-get update -y --fix-missing && \
    apt-get -y upgrade && \
    apt-get -y dist-upgrade && \
    apt-get install -y cron rsyslog && \
    apt-get install -y build-essential && \
    apt-get install -y software-properties-common && \
    apt-get install -y curl man unzip vim wget nano bash-completion;

# Monitoring tools
RUN \
    apt-get install -y htop net-tools inetutils-ping telnet;

# Developing tools
RUN \
    apt-get install -y git redis-tools mysql-client;

# installing php 7.1
RUN \
    add-apt-repository -y ppa:ondrej/php && \
    apt-get update -y;
RUN \
    apt-get install -y php7.1 php7.1-cli php7.1-curl php7.1-fpm php7.1-gd php7.1-imap && \
    apt-get install -y php7.1-json php7.1-mbstring php7.1-mcrypt php7.1-mysql php7.1-opcache php7.1-soap && \
    apt-get install -y php7.1-sqlite3 php7.1-xml php7.1-xmlrpc php7.1-xsl php7.1-zip php7.1-intl phpunit;

# create unix socket for php-fpm
RUN \
    mkdir -p /run/php && \
    touch /run/php/php7.1-fpm.sock;

# installing servers
RUN \
    apt-get install -y nginx;

# Setup s6 services
ADD ./services/run-nginx.sh /etc/services.d/nginx/run
ADD ./services/run-php-fpm.sh /etc/services.d/php-fpm/run

# Setup s6 stages
ADD ./stages/fix-attrs.d/ /etc/fix-attrs.d/
ADD ./stages/cont-init.d/ /etc/cont-init.d/
ADD ./stages/cont-finish.d/ /etc/cont-finish.d/

# Customizing s6 behaviour
# 0: Continue silently even if any script (fix-attrs or cont-init) has failed.
# 1: Continue but warn with an annoying error message.
# 2: Stop by sending a termination signal to the supervision tree.
ENV S6_BEHAVIOUR_IF_STAGE2_FAILS 2
# The maximum time (in milliseconds) a script in /etc/cont-finish.d could take before sending a KILL signal to it.
ENV S6_KILL_FINISH_MAXTIME 15000
# How long (in milliseconds) s6 should wait to reap zombies before sending a KILL signal.
ENV S6_KILL_GRACETIME 30000

# Define default command.
CMD ["/init"]