<?php

namespace eduslim\domain;

use Exception;

/**
 * Exceptions hierarchy
 */

class BaseException extends Exception{};
    class DaoException extends BaseException{};
        class ManagerException extends DaoException{};
            class ServiceException extends ManagerException{};
