# Railway Deployment Guide

1. Push repository ke GitHub.
2. Create a new project in Railway.
3. Connect the GitHub repository.
4. Set the following environment variables in Railway:
   - APP_ENV=production
   - APP_DEBUG=false
   - APP_URL=https://your-app.up.railway.app
   - DB_CONNECTION=sqlite
5. Deploy.

If you want to use a real database on Railway, replace sqlite with mysql or pgsql and provide the corresponding DB_* variables.
