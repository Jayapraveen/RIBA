from chatterbot.trainers import ChatterBotCorpusTrainer
from chatterbot import ChatBot

chatbot = ChatBot('RIBA')
trainer = ChatterBotCorpusTrainer(chatbot)
trainer.train("chatterbot.corpus.english",
"./deploy/rec/rec.yml"
)
