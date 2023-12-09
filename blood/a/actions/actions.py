# This files contains your custom actions which can be used to run
# custom Python code.
#
# See this guide on how to implement these action:
# https://rasa.com/docs/rasa/custom-actions


# This is a simple example for a custom action which utters "Hello World!"

# actions.py

# actions.py

# actions.py

from typing import Any, Text, Dict, List
from rasa_sdk import Action, Tracker
from rasa_sdk.executor import CollectingDispatcher
from pymongo import MongoClient


class ActionStoreChatConversation(Action):
    def name(self) -> Text:
        return "action_store_chat_conversation"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: Dict[Text, Any]) -> List[Dict[Text, Any]]:
        # Extract user and bot messages from the tracker
        conversation = [
            {"sender": "User", "message": event.get('text')}
            for event in tracker.events if event.get('event') == 'user'
        ]

        # Connect to MongoDB
        client = MongoClient('mongodb://localhost:27017/')
        db = client['rasa_chats']
        conversations_collection = db['conversations']

        # Save the conversation to MongoDB
        conversations_collection.insert_one({"conversation": conversation})

        return []
