FROM node:lts-alpine

WORKDIR /app

COPY ./frontend/package*.json ./

RUN npm install

COPY ./frontend .

RUN npm run build

RUN npm install -g http-server

EXPOSE 8080

CMD ["http-server", "dist"]
