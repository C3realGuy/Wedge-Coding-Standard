<?php
/**
 * Wedge_Sniffs_Comments_WhitespaceAfterSingleLineCommentSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   Wedge_Standard
 */

/**
 * Wedge_Sniffs_Comments_WhitespaceAfterSingleLineCommentSniff.
 *
 * Checks that after single line comments there's a whitespace.
 * Correct Example:
 *   # This is a comment
 *   // This is another comment
 *
 * Incorrect Example:
 *   #This is a bad comment
 *   //This is another bad comment
 *
 * @category  PHP
 * @package   Wedge_Standard
 */
class Wedge_Sniffs_Comments_WhitespaceAfterSingleLineCommentSniff implements PHP_CodeSniffer_Sniff
{
	/**
	 * Returns the token types that this sniff is interested in.
	 *
	 * @return array(int)
	 */
	public function register()
	{
		return array(T_COMMENT);

	}

	/**
	 * Processes the tokens that this sniff is interested in.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
	 * @param int				  $stackPtr  The position in the stack where
	 *										the token was found.
	 *
	 * @return void
	 */
	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();
		$isDoubleSlash = $tokens[$stackPtr]['content']{0} === '/';
		$isHash = $tokens[$stackPtr]['content']{0} === '#';
		$whitespacePos = $isDoubleSlash === true ? 2 : 1;
		// var_export([$isDoubleSlash, $isHash, $whitespacePos, $tokens[$stackPtr]['content']{$whitespacePos}]);
		if ($tokens[$stackPtr]['content']{$whitespacePos} !== ' ') {
			$error = 'Whitespace after comment required';
			$data  = array(trim($tokens[$stackPtr]['content']));
			$fix   = $phpcsFile->addFixableError($error, $stackPtr, 'Found', $data);
			if ($fix === true) {
				$phpcsFile->fixer->beginChangeset();
				var_dump($tokens[$stackPtr]['content']);
				$newComment = ($isDoubleSlash ? '// ' : '# ') . substr($tokens[$stackPtr]['content'], $whitespacePos);
				$phpcsFile->fixer->replaceToken($stackPtr, $newComment);
				$phpcsFile->fixer->endChangeset();
			}
		}
	}
}
?>
