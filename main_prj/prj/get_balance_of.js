async function getBalanceOf(uaddr) {
    const ganache_url = "http://localhost:8545";
    const gas_cost = 3960375;
    web3 = new Web3(new Web3.providers.HttpProvider(ganache_url));
    var result = await web3.eth.getBalance(uaddr);
    return result;
}
