from sqlalchemy import create_engine
import pymysql
import pandas as pd
from sklearn.tree import DecisionTreeClassifier
from sklearn.model_selection import train_test_split

db_connection = 'mysql+pymysql://root:S1freyokki@localhost/laravel'
conn = create_engine(db_connection)

df = pd.read_sql("SELECT rateds.user_id, rateds.movie_id, (rateds.rate - 1)*25 as rate FROM rateds WHERE rateds.rate > 0", conn)

X = df.drop(columns=['rate'])
y = df['rate']

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2)

model = DecisionTreeClassifier()
model.fit(X, y)
predictions = model.predict([ [7, 603] ])

score = accuracy_score(y_test, predictions)
print(score)