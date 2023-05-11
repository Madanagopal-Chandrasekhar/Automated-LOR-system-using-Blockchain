<?php include ( "db.php" ); ?>
<?php 
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
    $uname_db="";
    $wallet_gov="";
}
else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con,"SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);
			$uname_db = $get_user_email['firstName'];
            $wallet_gov = $get_user_email['Wallet_address'];
}
if($wallet_gov!="0xC18D9745733B83C0102135b629AeAb3F59957A32"){
    session_destroy();
    setcookie('user_login', '', 0, "/");
    header("Location: index.php");
}   
?>
<!DOCTYPE html>
<html>

<head>
    <title>Letter Of Recommendation for Higher Studies</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.2.7-rc.0/web3.min.js"></script>

    <?php
            $con = mysqli_connect("localhost","root","") or die("Error ".mysqli_error($con));
            mysqli_select_db($con,'blockchain') or die("cannot select DB"); ?>
</head>

<body>
    <?php include ( "main.php" ); ?>
    <div class="names" style="text-align: center;">
        <p class="titles">APPROVE RECOMMENDATION LETTER</p><br><br>
        <label for="ID1">Recommendation Letter ID:</label>
        <input type="text" id="ID1"><br><br>
        
        <button onclick="approveRecom()" id="approveRecom" class="uisignupbutton">Approve Recommendation</button><br><br><br>
        <label>Get Recommendation Details By ID:</label><br><br>
        <input type="text" id="ID1"><br><br>
        <button onclick="getRecom()" class="uisignupbutton">Get Recommendation Details</button> <br>
        <p id="dataArea"></p>
    </div>

    <script>
        let account;
        const init = async () => {
            if (window.ethereum !== "undefined") {
                const accounts = await ethereum.request({ method: "eth_requestAccounts" });
                account = accounts[0];
            }
            const ABI = [
                {
                "anonymous": false,
                "inputs": [
                    {
                    "indexed": true,
                    "internalType": "uint256",
                    "name": "id",
                    "type": "uint256"
                    },
                    {
                    "indexed": false,
                    "internalType": "address",
                    "name": "requester",
                    "type": "address"
                    },
                    {
                    "indexed": false,
                    "internalType": "string",
                    "name": "studentName",
                    "type": "string"
                    },
                    {
                    "indexed": false,
                    "internalType": "string",
                    "name": "university",
                    "type": "string"
                    },
                    {
                    "indexed": false,
                    "internalType": "string",
                    "name": "program",
                    "type": "string"
                    }
                ],
                "name": "NewRecommendation",
                "type": "event"
                },
                {
                "anonymous": false,
                "inputs": [
                    {
                    "indexed": true,
                    "internalType": "uint256",
                    "name": "id",
                    "type": "uint256"
                    },
                    {
                    "indexed": false,
                    "internalType": "address",
                    "name": "approver",
                    "type": "address"
                    }
                ],
                "name": "RecommendationApproved",
                "type": "event"
                },
                {
                "inputs": [
                    {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                    }
                ],
                "name": "recommendations",
                "outputs": [
                    {
                    "internalType": "address",
                    "name": "requester",
                    "type": "address"
                    },
                    {
                    "internalType": "string",
                    "name": "studentName",
                    "type": "string"
                    },
                    {
                    "internalType": "string",
                    "name": "university",
                    "type": "string"
                    },
                    {
                    "internalType": "string",
                    "name": "program",
                    "type": "string"
                    },
                    {
                    "internalType": "string",
                    "name": "recommendationLetter",
                    "type": "string"
                    },
                    {
                    "internalType": "bool",
                    "name": "approved",
                    "type": "bool"
                    }
                ],
                "stateMutability": "view",
                "type": "function",
                "constant": true
                },
                {
                "inputs": [
                    {
                    "internalType": "string",
                    "name": "_studentName",
                    "type": "string"
                    },
                    {
                    "internalType": "string",
                    "name": "_university",
                    "type": "string"
                    },
                    {
                    "internalType": "string",
                    "name": "_program",
                    "type": "string"
                    },
                    {
                    "internalType": "string",
                    "name": "_recommendationLetter",
                    "type": "string"
                    }
                ],
                "name": "addRecommendation",
                "outputs": [
                    {
                    "internalType": "uint256",
                    "name": "id",
                    "type": "uint256"
                    }
                ],
                "stateMutability": "nonpayable",
                "type": "function"
                },
                {
                "inputs": [
                    {
                    "internalType": "uint256",
                    "name": "id",
                    "type": "uint256"
                    }
                ],
                "name": "approveRecommendation",
                "outputs": [],
                "stateMutability": "nonpayable",
                "type": "function"
                },
                {
                "inputs": [
                    {
                    "internalType": "uint256",
                    "name": "id",
                    "type": "uint256"
                    }
                ],
                "name": "getRecommendation",
                "outputs": [
                    {
                    "internalType": "address",
                    "name": "",
                    "type": "address"
                    },
                    {
                    "internalType": "string",
                    "name": "",
                    "type": "string"
                    },
                    {
                    "internalType": "string",
                    "name": "",
                    "type": "string"
                    },
                    {
                    "internalType": "string",
                    "name": "",
                    "type": "string"
                    },
                    {
                    "internalType": "string",
                    "name": "",
                    "type": "string"
                    },
                    {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                    }
                ],
                "stateMutability": "view",
                "type": "function",
                "constant": true
                }
            ];
            const Address = "0x0cC72D33cE94547FCbC9046843bB9747DB84252F";
            window.web3 = await new Web3(window.ethereum);
            window.contract = await new window.web3.eth.Contract(ABI, Address);
        }
        init();

        var priObj = function (obj) {
            var string = 'Requester Address: ';
            let i = 0;
            for (var prop in obj) {
                if (typeof obj[prop] == 'string') {
                    //string += prop + ': ' + obj[prop] + '; </br>';
                    string += obj[prop] + '</br>';
                    i++;
                }
                if (typeof obj[prop] == 'boolean') {
                    //string += prop + ': ' + obj[prop] + '; </br>';
                    string += obj[prop] + '</br>';
                    i++;
                }
                if(i==1)
                {
                    string += 'Student Name: ';
                }
                if(i==2)
                {
                    string += 'University: ';
                }
                if(i==3)
                {
                    string += 'Program: ';
                }
                if(i==4)
                {
                    string += 'Recommendation Letter: ';
                }
                if(i==5)
                {
                    string += 'Is Approved? : ';
                }
                //else {
                //string += prop + ': { </br>' + print(obj[prop]) + '}';
                //}
            }

            return string;
        }

        const approveRecom = async () => {
            const RecomID = document.getElementById("ID1").value;
            if(account==<?php echo $wallet_gov?>){
                await window.contract.methods.approveRecommendation(RecomID).send({ from: account });
            }
            else{
                document.getElementById("dataArea").innerHTML = "This can be done only using the Professor's Wallet"
            }    
        }
        const getRecom = async () => {
            const recom = document.getElementById("ID1").value;
            const data = await window.contract.methods.getRecommendation(recom).call();
            document.getElementById("dataArea").innerHTML = priObj(data);
        }
    </script>
</body>

</html>