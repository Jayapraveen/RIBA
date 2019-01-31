from chatterbot.trainers import ChatterBotCorpusTrainer
from chatterbot import ChatBot
import os
print(os.getcwd())
wd = os.getcwd()

chatbot = ChatBot('RIBA')
trainer = ChatterBotCorpusTrainer(chatbot)

ON_HEROKU = os.environ.get('ON_HEROKU')

if ON_HEROKU:
    os.system("wget http://riba-support.000webhostapp.com/RIBA/training-data/rec.yml")
    trainer.train("chatterbot.corpus.english",
    wd + "/rec.yml"
    )

else: #on Travis
    trainer.train("chatterbot.corpus.english",
    wd + "/rec/rec.yml"
    )
