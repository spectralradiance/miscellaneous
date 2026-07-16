import firebase from 'firebase'

// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyASSVHzgHxcXA3nNbjY5SKnODWm_EHVSck",
    authDomain: "aapdx-a04f5.firebaseapp.com",
    databaseURL: "https://aapdx-a04f5.firebaseio.com",
    projectId: "aapdx-a04f5",
    storageBucket: "aapdx-a04f5.appspot.com",
    messagingSenderId: "378477776604",
    appId: "1:378477776604:web:4d27dfb4c2f28f61cbee19",
    measurementId: "G-R5DD8E3PJX"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
firebase.analytics();
