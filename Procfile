release: psql $DATABASE_URL -f drop_schema.sql ;python ./deploy/manage.py migrate ;python ./deploy/train_riba.py
web: gunicorn --chdir /app/deploy riba.wsgi --log-file -
