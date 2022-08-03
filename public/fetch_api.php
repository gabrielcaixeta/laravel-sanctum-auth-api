<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script>
        let token = "7|Krr2X2v2SHWyRtcZ1JgtjtTqjsh1ycxVUsB2lS6t";
        const url = "http://127.0.0.1:8000/api/v1";

        // let data = new FormData();
        // data.append('email', 'teste@gmail.com');
        // data.append('password', 'password');
            
        // fetch(`${url}/auth/login`, {
        //     method: 'POST',
        //     body: data
        // })
        // .then(resp => resp.json())
        // .then(json => {
        //     console.log(json);
        //     token = json.data.token;
        //     getMe();
        // });
    
        // function getMe(){
        //     fetch(`${url}/me`, {
        //         headers: {
        //             credentials: 'include',
        //             Accept: 'application/json',
        //             Authentication: `Bearer ${token}`
        //         }
        //     })
        //     .then(resp => resp.json())
        //     .then(json => console.log(json));
        // }
        const token2 = localStorage.getItem("token")
        if(localStorage.getItem("token") != null){
            // window.location.assign("http://google.com.br"); // redireciona para a home

        }
        localStorage.setItem("text1", 'document.form1.text1.value');

        var myHeaders = new Headers();
        myHeaders.append("Authorization", `Bearer ${token}`);

        var requestOptions = {
        method: 'GET',
        headers: myHeaders,
        // redirect: 'follow'
        };

        fetch("http://localhost:8000/api/v1/me", requestOptions)
        .then(response => response.text())
        .then(result => console.log(result))
        .catch(error => console.log('error', error));
    </script>
</body>
</html>