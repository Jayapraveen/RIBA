release: python ./deploy/manage.py migrate ; python ./deploy/manage.py train
web: gunicorn --chdir /app/deploy riba.wsgi --log-file -
