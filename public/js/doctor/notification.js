import { ref, onChildAdded, onValue } from '/js/doctor/firebase_connection.js';

 async function notifications(){
    const messagelistener = ref(database, `administrator/chats/`);
    const requestlistener = ref(database, `administrator/doctors/${docID}/Appointments/`);
        onChildAdded(messagelistener, async (snapshot) => {
        const messKey = snapshot.key;
            if(messKey.includes(docID)){
                const newmessagelistener = ref(database, `administrator/chats/${messKey}`);
                onChildAdded(newmessagelistener, async (snapshot2) => {
                    const message = snapshot2.val();
                    if(!message.seen){
                        // popnotification.play();
                        document.getElementById('patient-notif').style.display = "block";
                    }
                    else{
                        document.getElementById('patient-notif').style.display = "none";
                    }
                })
            }
        })

        onChildAdded(requestlistener, async (snapshot) => {
            if(requestlistener){
                document.getElementById('request-notif').style.display = "block";
            }
        })
    
    }

    function removeNotification(){
        document.getElementById('patient-btn').addEventListener('click', () => {
            viewedState = true;
            document.getElementById('patient-notif').style.display = "none";
        })
    }

window.notifications = notifications;
window.removeNotification = removeNotification;