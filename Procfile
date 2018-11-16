release: python ./deploy/manage.py migrate ; python ./deploy/manage.py train
web: gunicorn --chdir /app/deploy example_app.wsgi --log-file -
