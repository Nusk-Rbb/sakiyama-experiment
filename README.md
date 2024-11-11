# Sakiyama Group Experiment

## Install packages

### Ubuntu

Add Docker repository

```sh
# Add Docker's official GPG key:
sudo apt update
sudo apt install ca-certificates curl
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc

# Add the repository to Apt sources:
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
sudo apt update
```

Setup Docker
```sh
    sudo groupadd docker
    sudo usermod -aG docker <user name>
```
Start Docker
```sh
sudo systemctl enable --now docker
```

Install Docker
```sh
sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

### Red Hat

Add Docker Repository

```sh
sudo dnf -y install dnf-plugins-core
sudo dnf config-manager --add-repo https://download.docker.com/linux/rhel/docker-ce.repo
```

Install Docker
```sh
sudo dnf install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

Start Docker
```sh
sudo systemctl enable --now docker
```

### Arch Linux

Install Docker

```sh
sudo pacman -S docker docker-compose
```

Start and Enable Docker
```sh
sudo systemctl enable --now docker.service
```

## 3

### How to run

```sh
cd 3
docker compose up -d
```

### How to stop container

```sh
docker compose down
```

## 4

### How to run

```sh
cd 4/
docker compose up -d --build
```