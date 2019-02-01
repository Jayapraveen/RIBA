from chatterbot.trainers import ChatterBotCorpusTrainer
from chatterbot import ChatBot
import os
import dj_database_url

print(os.getcwd())
wd = os.getcwd()

ON_HEROKU = os.environ.get('ON_HEROKU')

if ON_HEROKU:
    uri = os.environ.get('DATABASE_URL')
    chatbot = ChatBot('RIBA',
    storage_adapter='chatterbot.storage.SQLStorageAdapter',
    database_uri=uri)
    trainer = ChatterBotCorpusTrainer(chatbot)
    os.system("wget http://riba-support.000webhostapp.com/RIBA/training-data/rec.yml")
    trainer.train("chatterbot.corpus.english.greetings",
    "chatterbot.corpus.english.ai",
    "chatterbot.corpus.english.literature",
    "chatterbot.corpus.english.psycology",
    "chatterbot.corpus.english.science",
    "chatterbot.corpus.english.computers",
    "chatterbot.corpus.english.conversations",
    "chatterbot.corpus.english.emotion",
    wd + "/rec.yml"
    )

else: #on Travis
    chatbot = ChatBot('RIBA')
    trainer = ChatterBotCorpusTrainer(chatbot)
    trainer.train("chatterbot.corpus.english",
    wd + "/rec/rec.yml"
    )
