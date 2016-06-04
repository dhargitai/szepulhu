FROM dahlb/alpine-node

RUN mkdir -p /var/build
RUN mkdir -p /var/build-tools
RUN mkdir -p /var/target

VOLUME /var/src         # Directory of source files
VOLUME /var/compiler    # Directory of the entry script "compiler.sh".
VOLUME /var/target      # Directory of the build output.

ENV GULP_TARGET_DIR="/var/target"

# Install packages with NPM
WORKDIR /var/build-tools
ADD package.json /var/build-tools/
RUN apk add --no-cache make gcc g++ binutils-gold python && \
    npm install && \
    apk del make gcc g++ binutils-gold python && \
    rm -rf /var/cache/apk/*
ENV PATH="/var/build-tools/node_modules/.bin:$PATH"
ENV NODE_PATH="/var/build-tools/node_modules"

# Install packages with Bower
WORKDIR /var/build
ADD bower.json /var/build/
RUN bower --config.interactive=false --allow-root install
ENV GULP_LIB_DIR="/var/build"

WORKDIR /var/src

CMD ["/var/compiler/compiler.sh"]