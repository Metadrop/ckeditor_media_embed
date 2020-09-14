<?php

namespace Drupal\ckeditor_media_embed\Command;

// @codingStandardsIgnoreLine
use Drupal\Console\Annotations\DrupalCommand;
use Drupal\Console\Core\Command\Command;
use Drupal\Console\Core\Command\Shared\ContainerAwareCommandTrait;
use Drupal\Console\Core\Style\DrupalStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class InstallCommand.
 *
 * @package Drupal\ckeditor_media_embed
 *
 * @DrupalCommand (
 *     extension="ckeditor_media_embed",
 *     extensionType="module"
 * )
 */
class InstallCommand extends Command {

  use ContainerAwareCommandTrait;

  /**
   * The CKEditor Media Embed CLI Commands service.
   *
   * @var \Drupal\ckeditor_media_embed\CLICommands
   */
  protected $cliCommands;

  /**
   * {@inheritdoc}
   */
  public function __construct(\Drupal\ckeditor_media_embed\CLICommands $cliCommands) {
    parent::__construct();
    $this->cliCommands = $cliCommands;
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('ckeditor_media_embed:install')
      ->setDescription($this->trans('commands.ckeditor_media_embed.install.description'));
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->input = $input;
    $this->output = $output;
    $this->io = new DrupalStyle($input, $output);

    $overwrite = $this->cliCommands->askToOverwritePluginFiles($this);

    if ($overwrite) {
      $this->cliCommands->overwritePluginFiles($this, $overwrite);
    }
  }

  /**
   * Return requested message.
   *
   * @param string $message_key
   *   The key of the requested message.
   *
   * @return string
   *   The requested message.
   */
  public function getMessage($message_key) {
    return $this->trans("commands.ckeditor_media_embed.install.messages.$message_key");
  }

  /**
   * Present confirmation question to user.
   *
   * @param string $question
   *   The confirmation question.
   * @param $default
   *   The default value to return if user doesn’t enter any valid input.
   *
   * @return mixed
   *   The user answer.
   */
  public function confirmation($question, $default = FALSE) {
    $helper = $this->getHelper('question');
    $confirmation_question = new ConfirmationQuestion($question, $default);

    return $helper->ask($this->input, $this->output, $confirmation_question);
  }

  /**
   * Output message in comment style.
   *
   * @param string $text
   *   The comment message.
   */
  public function comment($text) {
    $this->io->comment($text);
  }

}
