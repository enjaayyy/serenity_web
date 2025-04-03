 import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-app.js";
        import { getDatabase, ref, onChildAdded, child, get, update, remove, onValue } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-database.js";
        import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "AIzaSyCYLZvbqn9jnEQwwGNLZtbahdFLIBxksSc",
            authDomain: "serenity-c800c.firebaseapp.com",
            databaseURL: "https://serenity-c800c-default-rtdb.firebaseio.com",
            projectId: "serenity-c800c",
            storageBucket: "serenity-c800c.appspot.com",
            messagingSenderId: "366141859028",
            appId: "1:366141859028:web:1ffb51a714407fea7f4741",
        };

        const app = initializeApp(firebaseConfig);
        window.database = getDatabase(app);
        window.auth = getAuth(app);

        export { ref, onChildAdded, child, get, update, signInWithPopup, GoogleAuthProvider, remove, onValue };