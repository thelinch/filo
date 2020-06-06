<?php

namespace Filo\MenuCounterVotes\Domain;


interface MenuCounterVotesRepository
{
    function updateVotes(MenuCounterVotes $menuCounterVotes);
}
