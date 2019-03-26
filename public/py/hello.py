from sqlalchemy import create_engine
import pymysql
import pandas as pd
from sklearn.neural_network import MLPClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score


db_connection = 'mysql+pymysql://root:S1freyokki@localhost/laravel'
conn = create_engine(db_connection)

df = pd.read_sql("""
	SELECT rateds.user_id, rateds.movie_id, rateds.rate, movies.vote_count, movies.vote_average
	FROM rateds
	INNER JOIN
	    (SELECT user_id, Count(1) As count
	    FROM rateds
	    WHERE rate > 0
	    GROUP BY user_id) NG
	ON rateds.user_id = NG.user_id
	LEFT JOIN movies ON rateds.movie_id = movies.id 
	WHERE rateds.rate > 0 AND NG.count > 66
	""", conn)

X = df.drop(columns=['rate'])
y = df['rate']

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.1)

model = MLPClassifier(hidden_layer_sizes=(100))#,max_iter=250)
model.fit(X,y)

predictions = model.predict([[7,102651, 7878, 7]])

#score = accuracy_score(y_test, predictions)
print(predictions)