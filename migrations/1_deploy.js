const LetterOfRecommendation = artifacts.require("D:/Blockchain/DA/Project/contracts/LetterOfRecommendation.sol");

module.exports = function(deployer)
{
    deployer.deploy(LetterOfRecommendation);
}