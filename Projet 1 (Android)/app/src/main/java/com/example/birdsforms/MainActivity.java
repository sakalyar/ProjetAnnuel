package com.example.birdsforms;

import android.annotation.SuppressLint;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.QueryDocumentSnapshot;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;

public class MainActivity extends AppCompatActivity {

    private EditText email, numberOfBirds, password;
    private Button save, send, clear, load;
    private RadioButton redBookIncludedButton, redBookExcludedButton;
    private TextView list;
    private boolean rareSpeciesObserved;
    private String coordinates;

    private final DataBaseHelper dataBaseHelper = new DataBaseHelper(MainActivity.this);
    private GPS gps;

    private boolean[] selectedBirds;
    private ArrayList<Integer> birdsList;
    private static final String[] birdsArray = {"Linote mélodieuse", "Pigeon", "Ibis sacré",
            "Poule sauvage", "Kiwi"
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        initialize();

        save.setOnClickListener(v -> {
            coordinates = gps.coordinates(MainActivity.this);
            WatcherModel watcherModel;
            try {
                dataBaseHelper.DeleteAll();
                String x = addBirdsListToDatabase() + " ";
                watcherModel = new WatcherModel(email.getText().toString(),
                        Integer.parseInt(numberOfBirds.getText().toString()), rareSpeciesObserved, x, coordinates);
                Toast.makeText(MainActivity.this, "Sauvegardé avec succès", Toast.LENGTH_SHORT).show();
            } catch (Exception ex) {
                Toast.makeText(MainActivity.this, "Erreur de sauvegarde !", Toast.LENGTH_SHORT).show();
                return;
            }
            dataBaseHelper.addOne(watcherModel);
        });

        send.setOnClickListener(v -> {
            FirebaseFirestore db = FirebaseFirestore.getInstance();
            ArrayList<Object> users = new ArrayList<>();
            // récupérons la collection des utilisateurs
            db.collection("UsersDB")
                    .get()
                    .addOnCompleteListener(task -> {
                        if (task.isSuccessful()) {
                            for (QueryDocumentSnapshot document : task.getResult()) {
                                users.add(document.getData().values());
                            }
                            for (Object o : users) {
                                String[] x = parser(o);
                                String s = email.getText().toString();

                                // Si le mot de passe encrypté est le meme que le hash sauvegardé
                                // et l'email coincide, on est autorisé
                                if (PasswordEncryptor.encryptThisString(password.getText().toString()).equals(x[1]) &&
                                        s.equals(x[0])) {
                                    Toast.makeText(MainActivity.this, "Authorization réussie", Toast.LENGTH_SHORT).show();
                                    Toast.makeText(MainActivity.this, "Téléchargement réussie", Toast.LENGTH_SHORT).show();
                                    dataBaseHelper.PushOnline();
                                    return;
                                }
                            }
                            Toast.makeText(MainActivity.this, "Email ou mot de passe sont incorrects!", Toast.LENGTH_SHORT).show();
                        } else {
                            Toast.makeText(MainActivity.this, "Erreur critique", Toast.LENGTH_SHORT).show();
                        }
                    });
        });

        // Efface tous les champs de text
        clear.setOnClickListener(v -> {
            email.setText("");
            numberOfBirds.setText("");
            password.setText("");
            for (int i = selectedBirds.length;i > 0;)
                selectedBirds[--i] = false;
            for (int j = 0; j < selectedBirds.length; j++) {
                selectedBirds[j] = false;
                birdsList.clear();
                list.setText("");
            }
            redBookIncludedButton.setChecked(false);
            redBookExcludedButton.setChecked(false);
        });

        // récupère tous les données sur utilisateur sauf pour le mot de passe et les fait entrer dans edittexts
        load.setOnClickListener(v -> {
            try {
                DataBaseHelper dataBaseHelper = new DataBaseHelper(MainActivity.this);
                WatcherModel watcher;
                watcher = dataBaseHelper.getWatcher().get(0);
                // effaçons l'utilisateur préalablement sauvegardé
                clear.performClick();
                email.setText(watcher.getName());

                loadBirds();
                numberOfBirds.setText(Integer.toString(watcher.getNumberOfBirds()));
                if(watcher.getRareBirdsDetector())
                    redBookIncludedButton.performClick();
                else
                    redBookExcludedButton.performClick();
            } catch (Exception ex) {
                // ne fait rien, on récupère tout ce qui était sauvegardé
            }
        });
    }

    @SuppressLint("NonConstantResourceId")
    public void onRadioButtonClicked(View view) {
        boolean checked = ((RadioButton) view).isChecked();
        switch(view.getId()) {
            case R.id.redBookIncludedButton:
                if (checked) {
                    rareSpeciesObserved = true;
                    redBookExcludedButton.setChecked(false);
                    break;
                }
            case R.id.redBookExcludedButton:
                if (checked) {
                    rareSpeciesObserved = false;
                    redBookIncludedButton.setChecked(false);
                    break;
                }
        }
    }

    private String addBirdsListToDatabase() {
        StringBuilder birdsListString = new StringBuilder();
        int cnt = Integer.parseInt(numberOfBirds.getText().toString());
        for (int i = 0, s = selectedBirds.length; i < s; ++i) {
            if (selectedBirds[i] && cnt-- != 0)
                birdsListString.append(birdsArray[i]).append("; ");
        }
        return birdsListString.toString();
    }

    // Liste des oiseaux
    private void birdsList() {
        /*La liste deroulante: */
        selectedBirds = new boolean[birdsArray.length];
        list = findViewById(R.id.birdsList);
        list.setOnClickListener(view -> {
            AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
            builder.setTitle("Choisissez un ou plusieurs oiseaux");
            builder.setCancelable(false);

            builder.setMultiChoiceItems(birdsArray, selectedBirds, (dialogInterface, i, b) -> {
                if (b) {
                    birdsList.add(i);
                    Collections.sort(birdsList);
                } else {
                    birdsList.remove(Integer.valueOf(i));
                }
            });

            builder.setPositiveButton("OK", (dialogInterface, i) -> {
                // Initialiser string builder
                StringBuilder stringBuilder = new StringBuilder();
                for (int j = 0; j < birdsList.size(); j++) {
                    stringBuilder.append(birdsArray[birdsList.get(j)]);
                    if (j != birdsList.size() - 1) {
                        stringBuilder.append(", ");
                    }
                }
                list.setText(stringBuilder.toString());
            });

            builder.setNegativeButton("Annuler", (dialogInterface, i) -> dialogInterface.dismiss());

            builder.setNeutralButton("Effacer tout", (dialogInterface, i) -> {
                for (int j = 0; j < selectedBirds.length; j++) {
                    selectedBirds[j] = false;
                    birdsList.clear();
                    list.setText("");
                }
            });
            builder.show();
        });
    }

    void initialize() {
        birdsList = new ArrayList<>();
        birdsList();

        save = findViewById(R.id.saveButton);
        load = findViewById(R.id.ViewAllButton);
        email = findViewById(R.id.EmailText);
        numberOfBirds = findViewById(R.id.numberOfBirds);
        redBookIncludedButton = findViewById(R.id.redBookIncludedButton);
        redBookExcludedButton = findViewById(R.id.redBookExcludedButton);
        clear = findViewById(R.id.clearButton);
        password = findViewById(R.id.passwordText);
        send = findViewById(R.id.pushDBButton);


        gps = new GPS();
        try {
            gps.initializeGPS(MainActivity.this);
        } catch (NullPointerException ex) {
            Toast.makeText(MainActivity.this, "Attention! GPS n'est pas accessible!", Toast.LENGTH_SHORT).show();
        }
    }

    void birdsParser() {
        String birds = dataBaseHelper.getWatcher().get(0).getBirds();
        String x = "";
        ArrayList<String> birdsSaved = new ArrayList<>(Arrays.asList(birdsArray));
        for (int i = 0, l = birds.length(); i < l; i++) {
            if (birds.charAt(i) == ';') {
                birdsList.add(birdsSaved.indexOf(x));
                selectedBirds[birdsSaved.indexOf(x)] = true;
                x = "";
                i++;
                continue;
            }
            x += birds.charAt(i);
        }
    }

    void loadBirds() {
        birdsParser();
        Collections.sort(birdsList);
        StringBuilder stringBuilder = new StringBuilder();
        for (int j = 0; j < birdsList.size(); j++) {
            stringBuilder.append(birdsArray[birdsList.get(j)]);
            if (j != birdsList.size() - 1) {
                stringBuilder.append(", ");
            }
        }
        list.setText(stringBuilder.toString());
    }

    String[] parser(Object o) {
        ArrayList<String> properties = new ArrayList<>();
        for (String x : o.toString().split(",")) {
            x = x.replace("[", "");
            x = x.replace("]", "");
            x = x.replace(" ", "");
            properties.add(x);
        }
        // recevons login et mot de pass pour chaque utilisateur
        return new String[] { properties.get(2), properties.get(0) };
    }
}
