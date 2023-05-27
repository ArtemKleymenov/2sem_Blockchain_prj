async function deploy(abi, bytecode) {    
    const url_deploy = "http://localhost:3000/get_status.php";
    const ganache_url = "http://localhost:8545";
    const gas_cost = 3960375;
    const post_contract_address = "http://localhost:3000/contract_usage.php"

    var is_deployed = await $.get(url_deploy, {is_deployed: 'is_deployed'});

    if(is_deployed != 'true') {
        await $.post(url_deploy, {is_deployed: "true"});

        web3 = new Web3(new Web3.providers.HttpProvider(ganache_url));
        // https://www.geeksforgeeks.org/how-to-deploy-contract-from-nodejs-using-web3/
        var contract = new web3.eth.Contract(abi);
        var accs = await web3.eth.getAccounts();
        console.log("Accounts:", accs);
        main_account = accs[0];
        // address that will deploy smart contract
        console.log("Default Account:", main_account);
        // https://docs.web3js.org/docs/tutorials/deploying_and_interacting_with_smart_contracts/
        var con_addr = await contract.deploy({ data: bytecode }).send({ from: main_account, gas: gas_cost });
        console.log('Contract address:', con_addr.options.address);
        await $.post(post_contract_address, {contract: con_addr.options.address});
    }
}
