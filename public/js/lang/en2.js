var locale = {
    // Short, common use
    view: 'view',
    profile: 'profile',
    winChance: 'win chance',
    win: 'win',
    lose: 'lose',

    // Unknown server error
    serverError: 'Unexpected server error!',

    // Fair check
    hashCheckSuccess: 'Hashes match!',
    hashCheckFailed: 'Hashes doesn\'t match!',

    // Trade token
    tradeTokenFailed: 'Failed to update trade token!',
    tradeTokenSuccess: 'Updated trade token! New token: %s',

    // Common sentences, used everywhere
    notLoggedIn: 'Not logged in!',
    notEnoughCoins: 'Not enough coins!',
    cannotParseValue: 'Cannot parse value!',

    // Common inventory sentences
    escrowError: 'Non zero escrow duration, mobile authenticator needed!',
    pendingOffer: 'Pending offer! Accept or decline before requesting another!',
    offerStateChange: 'Your offer #%s changed state from "%s" to "%s"',
    noTradeToken: 'Request failed, no trade token supplied! Go to account section to set trade URL!',

    // User inventory
    loadInventoryError: 'Cannot load user inventory, please try again later!',
    loadInventorySuccess: 'User inventory loaded!',
    loadInventoryCached: 'User inventory loaded from cache!',

    // Site inventory
    loadSiteInventoryError: 'Cannot load site inventory, please try again later!',
    loadSiteInventorySuccess: 'Site inventory loaded!',

    // Deposit
    depositOfferSent: 'Deposit offer sent, offer #%s',
    depositFailed: 'Deposit offer failed for unknown reason, please try again later...',
    depositOfferAccepted: 'Deposit offer #%s accepted! Coins added: %i!',
    depositRequestSent: 'Deposit request has been sent, please wait for confirmation!',
    depositNoItemsRequested: 'No item requested to deposit!',

    // Withdraw
    withdrawOfferSent: 'Withdraw offer sent, offer #%s, please wait for the bots to confirm the offer!',
    withdrawFailed: 'Withdraw offer failed for unknown reason, please try again later...',
    withdrawOfferAccepted: 'Withdraw offer #%s accepted!',
    withdrawRequestSent: 'Withdraw request has been sent, please wait for confirmation!',
    withdrawMultipleBots: 'Requested withdrawal from multiple bots!',
    withdrawNoItemsRequested: 'No item requested to withdraw!',
    withdrawItemsUnavailable: 'Items unavailable! Try refreshing the page!',
    cannotWithdraw: 'Withdraw offer failed for unknown reason, please try again later...',
    withdrawItemsAlreadyInTrade: 'One or more of selected items already in trade, please refresh the page!',
    withdrawSendError2: 'Offer failed for unknown reason!',
    withdrawSendError20: 'Offer failed, Steam service unavailable!',
    withdrawSendError25: 'Offer failed, limit exceeded!',
    withdrawSendError26: 'Offer failed, revoked! Please try again later!',
    withdrawSendError15: 'Offer failed, access denied!',
    withdrawSendError16: 'Offer failed, timeout!',
    withdrawDeposit: 'You need to deposit for %i coins AND play %i%% of the deposited coins before withdrawing!',
    withdrawBets: 'You need to bet at lease %i times before withdrawing!',
    withdrawNotEnoughDeposit: 'You need to deposit at least 2500 coins to withdraw!',
	withdrawNotEnoughBet: 'You need to play 50%% of what you deposited to withdraw!',
	withdrawNotEnoughWager: 'You did not wager enough!',
	
    // Chat
    chatUnknownCommand: 'Unknown chat command!',
    chatRootAccess: 'You need root access to execute this command!',
    chatAdminAccess: 'You need admin access to execute this command!',
    chatModAccess: 'You need moderator access to execute this command!',
    chatMissingParameters: 'Missing parameters',
    chatBanSuccess: 'Banned %s!',
    chatBanFail: 'Couldn\'t ban %s!',
    chatMuteSuccess: 'Muted %s!',
    chatMuteFail: 'Couldn\'t mute %s!',
    chatMuteStaff: 'Cannot mute staff!',
    chatUnmuteSuccess: 'Unmuted %s!',
    chatUnmuteFail: 'Couldn\'t unmute %s!',
    chatUnmuteStaff: 'Cannot unmute staff!',
    chatUnmuteNotMuted: '%s is not muted!',
    chatGiveSuccess: 'Given %i coins to %s!',
    chatGiveFail: 'Failed to give %i coins to %s!',
    chatSendSuccess: 'Sent %i coins to %s!',
    chatSendFail: 'Failed to send %i coins to %s!',
    chatSendReceived: 'Received %i coins from %s!',
    chatSendOutOfRange: 'Value out of range!',
    chatSendNotEnoughCoins: 'Not enough coins played to send coins! You have to play with %i coins before sending them to someone else!',
    chatSendNotEnoughDeposit: 'Deposit value too low, you have to deposit items valued for %i coins to use this command!',
    chatSendUnavailable: 'You can\'t send coins!',
    chatAccessLevelOutOfRange: 'Access level out of range! (0 - 128)',
    chatAccessLevelSuccess: 'Granted access level %i to %s!',
    chatAccessLevelFailed: 'Failed to grant access level %i to %s!',
    chatCoinsBalance: 'Site has %i coins, the inventory is worth %i coins while users owns %i coins!',
    chatVoucherUsed: 'Voucher already used!',
    chatVoucherUnknown: 'Unknown voucher!',
    chatVoucherFailed: 'Failed to redeem voucher!',
    chatVoucherSuccess: 'Voucher activated, coins were added to your account!',
    chatVoucherCreationFailed: 'Failed to create voucher!',
    chatVoucherCreationSuccess: 'Voucher created! Check the chat for details!',
    chatReferralUnknown: 'Unknown referral code!',
    chatReferralAlreadyUsed: 'You already used a code!',
    chatReferralFailed: 'Failed to activate referral code!',
    chatReferralSuccess: 'Activated referral code "%s", %i coins has been added to your balance!',
    chatReferralNoCSGO: 'You need CS:GO to activate referral code!',
    chatReferralOwnCode: 'Cannot use own code!',
    chatIsMuted: 'Chat is muted right now!',
    chatMuted: 'The chat has been muted!',
    chatUnmuted: 'The chat has been unmuted!',
    chatCooldown: 'Slow down! (%.2g sec)',
    chatNoBets: 'You need to play with %i coins to chat!',
    chatNotEnoughBets: 'Not enough coins played to chat! (%i/%i)',
    chatNotEnoughDeposits: 'Not enough deposited to chat! (%i/%i)',

    // Misc
    coins: 'Coins',
    junk: 'Junk',
    rolling: 'Rolling...',
    voucherBot: 'Voucher Bot',
    generatedVoucher: 'Generated new voucher for %i coins: %s Use it by typing "/voucher %s" in the chat!',
    sendCoins: 'Send coins',
    visitProfile: 'Visit profile',
    muteUser: 'Mute user',
    unmuteUser: 'Unmute user',
    createVoucher: 'Create voucher',
    giveCoins: 'Give coins',
    changeAccess: 'Change access level',
    checkCoins: 'Check site coins',
    redeemVoucher: 'Redeem voucher',
    muteChat: 'Mute chat',
    unmuteChat: 'Unmute chat',
    removeMessages: 'Remove all user\'s messages',
    removeMessage: 'Remove the message',

    // Affiliates
    affiliatesCollect: 'You\'re about to collect affiliates earnings (%i coins), please insert steamid you will to transfer the coins to',
    affiliatesSuccess: 'Collected the coins!',
    affiliatesNoIDSupplied: 'Failed to collect the coins! No target steamid supplied!',
    affiliatesNoUserFound: 'Failed to collect the coins! Target user not in the database!',
    affiliatesNoCoinsToCollect: 'Failed to collect the coins! No coins to collect!',
    updateRefFail: 'Failed to update referral code!',
    updateRefSuccess: 'Updated referral code!',
    updateRefAlreadyTaken: 'Failed to update referral code! Code already taken!',
    updateRefRefused: 'New referral code refused, must be longer than 4 characters!',
    affiliatesNoReferral: 'You have to create referral code in order to collect coins!',

    // Crash
    crashPlayFailed: 'Failed to place coins!',
    crashPlaySuccess: 'Placed %i coins!',
    crashMaxBet: 'Cannot place %i, maximum bet is %i!',
    crashMinBet: 'Cannot place %i, minimum bet is %i!',

    // Roulette
    roulettePlayFailed: 'Failed to place coins!',
    roulettePlaySuccess: 'Placed %i coins on %s! (%i/%i)',
    rouletteUnknownColor: 'Unknown roulette color!',
    rouletteMaxBets: 'Cannot place more than %i bets!',
    rouletteMaxBet: 'Cannot place %i, maximum bet is %i!',
    rouletteMinBet: 'Cannot place %i, minimum bet is %i!',
    
    // Coinflip
    coinflipPlayFailed: 'Failed to place coins!',
    coinflipPlaySuccess: 'Placed %i coins on %s!',
    coinflipUnknownColor: 'Unknown coinflip side!',
    coinflipMaxBet: 'Cannot place %i, maximum bet is %i!',
    coinflipMinBet: 'Cannot place %i, minimum bet is %i!',
    coinflipJoin: 'Joined to the game!',
    coinflipWon: 'You won %i coins on coinflip!',
    coinflipLost: 'You lost %i coins on coinflip!',
    coinflipAlreadyJoined: 'Players are in! Can\'t join!',
    coinflipPending: 'You cannot make more than one games!',
    coinflipOwner: 'You are the creator of this lobby. You can\'t join here!',
    coinflipJoined: 'Player joined to your coinflip lobby!',

    // Mines
    valueOutOfRange: 'Bet out of the range! (Min: %i, Max: %i)',
    
    //Free coins
    freeSuccess: 'Collected %i coins!',
    freeError: 'Error while getting free coins!',
    freeUsed: 'Already used! Next use in %ih %im %is!',
    freeNoCS: 'CS:GO is required to use that function!',
    freeBadNickname: 'You need to put "%s" in your nickname!',
    freeCooldown: 'Please wait a moment before the next check: %i minutes, %i seconds',
    freeNotInGroup: 'You need to join the group and put it as primary before redeeming the coins!'
};