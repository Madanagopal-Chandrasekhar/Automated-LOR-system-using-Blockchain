<?php include ( "db.php" ); ?>
<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
    $uname_db="";
    $wallet_user="";
}
else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con,"SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);
			$uname_db = $get_user_email['firstName'];
            $wallet_user = $get_user_email['Wallet_address'];
}   
?>
<!DOCTYPE html>
<html>

<head>
    <title>Letter Of Recommendation for Higher Studies</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.2.7-rc.0/web3.min.js"></script>

    <?php
            $con = mysqli_connect("localhost","root","") or die("Error ".mysqli_error($con));
            mysqli_select_db($con,'blockchain') or die("cannot select DB"); ?>
</head>

<body>
    <?php include ( "main.php" ); ?>
    <div class="names" style="text-align: center;">
        <p style="margin-top:200px;" class="titles">LOGIN</p><br><br>
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
        /*const readWord = async () => {
            const data = await window.contract.methods.getFlower().call();
            document.getElementById("dataArea").innerHTML = `Word is: ${data}`;
        }

        const changeWord = async () => {
            const myEntry = document.getElementById("inputArea").value;
            await window.contract.methods.changeFlower(myEntry).send({ from: account });
        }*/
        // var priObj = function (obj) {
        //     var string = '';

        //     for (var prop in obj) {
        //         if (typeof obj[prop] == 'string') {
        //             //string += prop + ': ' + obj[prop] + '; </br>';
        //             string += obj[prop] + '</br>';
        //         }
        //         //else {
        //         //string += prop + ': { </br>' + print(obj[prop]) + '}';
        //         //}
        //     }

        //     return string;
        // }
        // const readfarmer = async () => {
        //     const data = await window.contract.methods.getRecommendation(ID).call();
        //     document.getElementById("dataArea").innerHTML = priObj(data);
        // }

        // const registerfarmer = async () => {
        //     const myName = document.getElementById("name").value;
        //     const myLandarea = document.getElementById("landarea").value;
        //     const myAadharno = document.getElementById("aadharno").value;
        //     const myBankacc = document.getElementById("bankacc").value;
        //     const mySchemename = document.getElementById("schemename").value;
        //     await window.contract.methods.registerFarmer(myName, myLandarea, myAadharno, myBankacc, mySchemename).send({ from: account });
        //}
    </script>

    <!--<div class="title-bar">Direct Benefit Transfer System</div>

    <div class="button-container">
        <div class="text">Which User: </div>
        <button class="button"><a href="indexfinal.html">Farmers</a></button>
        <button class="button"><a href="ubuilds.php"></a>Government</button>
    </div> --->

</body>

</html>