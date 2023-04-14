// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

contract LetterOfRecommendation {
    
    // Structure for a letter of recommendation
    struct Recommendation {
        address requester;
        string studentName;
        string university;
        string program;
        string recommendationLetter;
        bool approved;
    }
    
    // Mapping to store recommendations
    mapping (uint256 => Recommendation) public recommendations;
    
    // Event to be emitted when a new recommendation is added
    event NewRecommendation(uint256 indexed id, address requester, string studentName, string university, string program);
    
    // Event to be emitted when a recommendation is approved
    event RecommendationApproved(uint256 indexed id, address approver);
    
    // Function to add a new recommendation
    function addRecommendation(string memory _studentName, string memory _university, string memory _program, string memory _recommendationLetter) public returns (uint256 id) {
        id = uint256(keccak256(abi.encodePacked(block.timestamp, msg.sender, _studentName, _university, _program)));
        recommendations[id] = Recommendation(msg.sender, _studentName, _university, _program, _recommendationLetter, false);
        emit NewRecommendation(id, msg.sender, _studentName, _university, _program);
        return id;
    }
    
    // Function to approve a recommendation
    function approveRecommendation(uint256 id) public {
        require(recommendations[id].requester != address(0), "Recommendation not found");
        require(msg.sender != recommendations[id].requester, "Cannot approve own recommendation");
        require(!recommendations[id].approved, "Recommendation already approved");
        recommendations[id].approved = true;
        emit RecommendationApproved(id, msg.sender);
    }
    
    // Function to get a recommendation by ID
    function getRecommendation(uint256 id) public view returns (address, string memory, string memory, string memory, string memory, bool) {
        return (recommendations[id].requester, recommendations[id].studentName, recommendations[id].university, recommendations[id].program, recommendations[id].recommendationLetter, recommendations[id].approved);
    }
}
