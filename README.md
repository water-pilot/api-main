# API Main - Symfony API Platform

Welcome to the `API Main` repository. This document will guide you through the steps required to set up and run the API locally for the first time.

## Getting Started

Follow these steps to get the API up and running on your local machine:

### 1. Clone the Repository

To get the source code onto your machine, run the following command:

```bash
git clone https://github.com/water-pilot/api-main.git
```

### 2. Download Required Files

Locate the `jwt` folder and the `.env` file on your Google Drive in the "Shared with me" section.

### 3. Add Files to the Project

Place the `jwt` folder inside the `config` directory of the project. Similarly, place the `.env` file at the root of the project.

### 4. Launch Docker

Run the following command to start Docker:

```bash
docker compose up
```

### 5. Access the Docker Container

Navigate to the container named `api-main-app`. The container name might vary, so please adjust the command if needed. For this guide, we'll use `api-main-app-1`:

```bash
docker exec -it api-main-app-1 /bin/bash
```

### 6. Execute Initialization Commands

While inside the container, run the following commands:

```bash
bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

**Note**: If you encounter any error messages during this step, you can safely ignore them.

### 7. Access the API Documentation

Now, the API should be up and running! Open your browser and go to:

```
http://127.0.0.1:8080/api
```

You should be presented with the API documentation where you can explore the available endpoints.

---

I hope this helps! Feel free to adjust as per your requirements.
