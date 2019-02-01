from chatterbot.trainers import ChatterBotCorpusTrainer
from chatterbot import ChatBot
import os
import dj_database_url

print(os.getcwd())
wd = os.getcwd()

ON_HEROKU = os.environ.get('ON_HEROKU')

if ON_HEROKU:
    dbi = dj_database_url.config()
    print(dbi)
    chatbot = ChatBot('RIBA',
    storage_adapter='chatterbot.storage.SQLStorageAdapter',
    database_uri= dbi)
    trainer = ChatterBotCorpusTrainer(chatbot)
    os.system("wget http://riba-support.000webhostapp.com/RIBA/training-data/rec.yml")
    trainer.train("chatterbot.corpus.english",
    wd + "/rec.yml"
    )

else: #on Travis
    chatbot = ChatBot('RIBA')
    trainer = ChatterBotCorpusTrainer(chatbot)
    trainer.train("chatterbot.corpus.english",
    wd + "/rec/rec.yml"
    )
