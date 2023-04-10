package com.example.birdsforms;

import androidx.annotation.NonNull;

public class WatcherModel {
    private final String email;
    private final String birds;
    private final boolean rareBirdsDetected;
    private final int numberOfBirds;
    private final String location;

    public WatcherModel (String email, int numberOfBirds,
                         boolean rareBirdsDetected, String birds, String location) {
        this.email = email;
        this.rareBirdsDetected = rareBirdsDetected;
        this.numberOfBirds = numberOfBirds;
        this.birds = birds;
        this.location = location;
    }

    public String getName() {
        return email;
    }

    public String getBirds() {
        return birds;
    }

    public int getNumberOfBirds() {
        return numberOfBirds;
    }

    public boolean getRareBirdsDetector() { return rareBirdsDetected; }

    public String getLocation() { return location; }

    @NonNull
    @Override
    public String toString() {
        return "WatcherModel{" +
                "email='" + email + '\'' +
                ", numberOfBirds=" + numberOfBirds +
                ", rareBirdsDetected: " + rareBirdsDetected +
                ", birds=" + birds +
                ", location=" + location +
                '}';
    }

}
