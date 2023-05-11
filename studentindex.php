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
        <p class="titles">Request Recommendation Letter:</p><br><br>
        <label for="studentName">Student Name:</label>
        <input type="text" id="studentName"><br><br>

        <label for="university">University:</label>
        <input type="text" id="university"><br><br>

        <label for="program">Program:</label>
        <input type="text" id="program"><br><br>

        <label for="recommendationLetter">Recommendation Letter:</label>
        <textarea id="recommendationLetter"></textarea><br><br>

        <button onclick="addRecom()" id="addRecom" class="uisignupbutton">Request LOR</button><br><br>
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
                //document.getElementById("accountArea").innerHTML = `Account is: ${account}`;
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
            //document.getElementById("contractArea").innerHTML = "Connection Status: Success";
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
        var x = <?php echo json_encode($wallet_gov); ?>;
        const readfarmer = async () => {
            const data = await window.contract.methods.getFarmerDetails(x).call();
            document.getElementById("dataArea").innerHTML = priObj(data);
        }

        const addRecom = async () => {
            const studentName = document.getElementById('studentName').value;
            const university = document.getElementById('university').value;
            const program = document.getElementById('program').value;
            const recommendationLetter = document.getElementById('recommendationLetter').value;
            const data = await window.contract.methods.addRecommendation(studentName, university, program, recommendationLetter)
            .send({ from: account })
            .on('receipt', function(receipt){
            alert('Recommendation added with ID: ' + receipt.events.NewRecommendation.returnValues.id);
            });
            document.getElementById("dataArea").innerHTML = 'Recommendation added with ID ' + receipt.events.NewRecommendation.returnValues.id;
        }
        const getRecom = async () => {
            const recom = document.getElementById("ID1").value;
            const data = await window.contract.methods.getRecommendation(recom).call();
            document.getElementById("dataArea").innerHTML = priObj(data);
        }
    </script>

</body>

</html>