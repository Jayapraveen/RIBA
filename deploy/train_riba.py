from chatterbot.trainers import ChatterBotCorpusTrainer
from chatterbot import ChatBot
import os
print(os.getcwd())
wd = os.getcwd()

chatbot = ChatBot('RIBA')
trainer = ChatterBotCorpusTrainer(chatbot)
trainer.train("chatterbot.corpus.english",
wd + "/rec/rec.yml"
)
