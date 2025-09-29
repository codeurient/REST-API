<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <script>
        let xhr = new XMLHttpRequest();

        xhr.open('GET', 'data.xml', true);

        xhr.onreadystatechange = function() {

            if (xhr.readyState === 4 && xhr.status === 200) {

                let xmlDoc = xhr.responseXML; // XML cavabı alınır

                let users = xmlDoc.getElementsByTagName('user');

                for (let i = 0; i < users.length; i++) {
                    let name = users[i].getElementsByTagName('name')[0].textContent;

                    let email = users[i].getElementsByTagName('email')[0].textContent;

                    let div = document.createElement('div');
                    div.textContent = `${name}`;
                    document.body.append(div);

                    let p = document.createElement('p');
                    p.textContent = `${name}`;
                    document.body.append(email);

                }
            }

        };
        xhr.send();
    </script>
</body>
</html>