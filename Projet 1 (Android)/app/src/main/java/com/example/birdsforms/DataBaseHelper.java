package com.example.birdsforms;
import static android.content.ContentValues.TAG;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import androidx.annotation.Nullable;

import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.FirebaseFirestore;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
public class DataBaseHelper extends SQLiteOpenHelper {

    public static final String WATCHER_TABLE = "WATCHER_TABLE";
    public static final String COLUMN_WATCHER_LOGIN = "WATCHER_LOGIN";
    public static final String BIRDS_WATCHED = "BIRDS_WATCHED";
    public static final String BIRDS_NUMBER = "BIRDS_NUMBER";
    public static final String RARE_BIRDS_DETECTED = "RARE_BIRDS_DETECTED";
    public static final String LAST_KNOWN_LOCATION = "LAST_KNOWN_LOCATION";

    DataBaseHelper(@Nullable Context context){
        super(context, "BirdsWatcherDB.db", null, 1);
    }
    @Override
    public void onCreate(SQLiteDatabase db) {
        String createTableStatement = "CREATE TABLE " + WATCHER_TABLE +
                " (" + COLUMN_WATCHER_LOGIN + " TEXT, " +
                BIRDS_NUMBER + " INT, " +
                RARE_BIRDS_DETECTED + " BOOLEAN, " +
                BIRDS_WATCHED + " TEXT, " +
                LAST_KNOWN_LOCATION + " TEXT)";
        db.execSQL(createTableStatement);
    }
    public void addOne(WatcherModel watcherModel) {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues cv = new ContentValues();

        cv.put(COLUMN_WATCHER_LOGIN, watcherModel.getName());
        cv.put(BIRDS_NUMBER, watcherModel.getNumberOfBirds());
        cv.put(RARE_BIRDS_DETECTED, watcherModel.getRareBirdsDetector());
        cv.put(BIRDS_WATCHED, watcherModel.getBirds());
        cv.put(LAST_KNOWN_LOCATION, watcherModel.getLocation());

        db.insert(WATCHER_TABLE, null, cv);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {}

    public void DeleteAll() {
        SQLiteDatabase db = this.getWritableDatabase();
        String queryString = "DELETE FROM " + WATCHER_TABLE;
        Cursor cursor = db.rawQuery(queryString, null);
        cursor.moveToFirst();
        cursor.close();
    }

    public void PushOnline() {
        String query = "SELECT * FROM " + WATCHER_TABLE;
        SQLiteDatabase db = this.getReadableDatabase();

        Cursor cursor = db.rawQuery(query, null);
        if (cursor.moveToFirst()) {
            do {
                String login = cursor.getString(0);
                int numberOfBirds = cursor.getInt(1);
                boolean rareBirds = (cursor.getInt(2) != 0);
                String birds = cursor.getString(3);
                String location = cursor.getString(4);

                String path = "BirdsWatcherDB/" + login;
                DocumentReference mDocRef = FirebaseFirestore.getInstance().document(path);

                Map<String, Object> dataToSave = new HashMap<>();

                dataToSave.put(COLUMN_WATCHER_LOGIN, login);
                dataToSave.put(BIRDS_NUMBER, numberOfBirds);
                dataToSave.put(RARE_BIRDS_DETECTED, rareBirds);
                dataToSave.put(BIRDS_WATCHED, birds);
                dataToSave.put(LAST_KNOWN_LOCATION, location);

                mDocRef.set(dataToSave).addOnCompleteListener(task -> {
                    if (task.isSuccessful()) {
                        Log.d(TAG, "Document enregistré");
                    } else {
                        Log.w(TAG, "Exception: ", task.getException());
                    }
                });
            } while (cursor.moveToNext());
        }
        cursor.close();
        db.close();
    }

    public List<WatcherModel> getWatcher() {
        List<WatcherModel> returnList = new ArrayList<>();

        String query = "SELECT * FROM " + WATCHER_TABLE;
        SQLiteDatabase db = this.getReadableDatabase();

        Cursor cursor = db.rawQuery(query, null);
        if (cursor.moveToFirst()) {
            do {
                String login = cursor.getString(0);
                int numberOfBirds = cursor.getInt(1);
                boolean rareBirds = (cursor.getInt(2) != 0);
                String birds = cursor.getString(3);
                String location = cursor.getString(4);
                System.out.println(login);
                WatcherModel newWatcher = new WatcherModel(login,
                        numberOfBirds, rareBirds, birds, location);
                returnList.add(newWatcher);

            } while (cursor.moveToNext());

        }
        cursor.close();
        db.close();
        return returnList;
    }
}
