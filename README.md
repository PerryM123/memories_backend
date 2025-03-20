# memories_backend

## Setup Local Environment

### 1. Add local domain to hosts file

※ In my case, my hosts file is located: /etc/hosts

```
127.0.0.1 local.memories.com
```

### 2. Clone project & docker & make commands

※ Docker Desktop is required. After installation, be sure to open it

```sh
$ cd ~/workspace
$ git clone git@github.com:PerryM123/memories_backend.git
$ cd memories_backend
# Build container. If you already built project before, instead, use: $ make up-with-build 
$ make up
$ make setup-local-env-files
```

### 3. Open local page

You should be able to see the laravel application using the local url: http://local.memories.com/

※ Also accesible from: http://localhost:8081/