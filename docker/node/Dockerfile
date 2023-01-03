# Using ubuntu because playwright isn't compatible with debian.
FROM node:18-bullseye-slim

ENV GOSU_VERSION=1.14 \
    RUN_USER="node"

COPY bin/entrypoint.sh /usr/bin/entrypoint

WORKDIR /srv

ENTRYPOINT ["/usr/bin/entrypoint"]

RUN export DEBIAN_FRONTEND=noninteractive \
	&& set -xe \
    && apt-get update \
    && apt-get upgrade -y curl \
    && npm -g i npm \
    && chmod a+x /usr/bin/entrypoint \
    \
    && `# User management for entrypoint` \
    && curl -L -s -o /bin/gosu https://github.com/tianon/gosu/releases/download/${GOSU_VERSION}/gosu-$(dpkg --print-architecture | awk -F- '{ print $NF }') \
    && chmod +x /bin/gosu \
    && chmod +x /usr/bin/entrypoint \
    && mkdir -p /home \
    && chown ${RUN_USER}:${RUN_USER} /home \
    \
    && `# Clean apt and remove unused libs/packages to make image smaller` \
    && npm cache clean --force \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false -o APT::AutoRemove::SuggestsImportant=false $BUILD_LIBS \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/www/* /var/cache/* /home/.composer/cache

CMD ["yarn", "run", "dev", "--port", "3000", "--host", "0.0.0.0"]
