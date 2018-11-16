release: python ./deploy/manage.py migrate ; python ./deploy/manage.py train ; python -c "import nltk; nltk.download('punkt')"
web: gunicorn --chdir /app/deploy example_app.wsgi --log-file -
