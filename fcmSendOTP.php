<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase.js"></script>

<script>
window.onload = function() {
    render();
};

function render() { alert('test');
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
    recaptchaVerifier.render();
}

function phoneAuth() { alert('test');
    //get the number
    var number = <?php echo $_GET['mobileNo']; ?>;
    // alert(number);
    //it takes two parameter first one is number and second one is recaptcha
    firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {
        //s is in lowercase
        window.confirmationResult = confirmationResult;
        coderesult = confirmationResult;
        console.log(coderesult);
        alert("Message sent");
    }).catch(function(error) {
        alert('false');
        alert(error.message);
    });
}
  // Your web app's Firebase configuration
    var firebaseConfig = {
  apiKey: "AIzaSyDOfQi5tzi0T2op18z94JHatHSBRasD2Dw",
  authDomain: "ecoex-portal.firebaseapp.com",
  projectId: "ecoex-portal",
  storageBucket: "ecoex-portal.appspot.com",
  messagingSenderId: "999865566900",
  appId: "1:999865566900:web:7985cbbad380930582b9e1",
  measurementId: "G-6YB7HY886C"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
     firebase.analytics();
</script>