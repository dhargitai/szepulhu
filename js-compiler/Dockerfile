FROM dahlb/alpine-node

# RUN apk --update --no-progress add nodejs unrar bash git

RUN mkdir -p /var/build

VOLUME /var/src

WORKDIR /var/src

RUN npm install -g --prefix /var/build/node_modules
RUN export PATH=$PATH:/var/build/node_modules
RUN bower --config.interactive=false install

CMD ["/var/builder/build.sh"]