<?php

namespace Drupal\ckeditor_media_embed\Commands;

use Drupal\ckeditor_media_embed\CLICommands;
use Drupal\Core\Serialization\Yaml;
use Drush\Style\DrushStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InstallCommand.
 */
class InstallCommand {

  /**
   * The CKEditor Media Embed CLI Commands service.
   *
   * @var \Drupal\ckeditor_media_embed\CLICommands
   */
  protected $cliCommands;

  /**
   * The messages displayed to the user at various steps of the installation.
   *
   * @var string[]
   */
  protected $messages;

  /**
   * Constructs command object.
   *
   * @param \Drupal\ckeditor_media_embed\CLICommands $cliCommands
   *   The CKEditor Media Embed CLI Commands service.
   * @param string $root
   *   The Drupal root.
   */
  public function __construct(CLICommands $cliCommands, $root) {
    $this->cliCommands = $cliCommands;

    $this->setMessages($root);
  }

  /**
   * Executes the command.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   An InputInterface instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   An OutputInterface instance.
   * @param \Drush\Style\DrushStyle $io
   *   The Drush i/o object.
   */
  public function execute(InputInterface $input, OutputInterface $output, DrushStyle $io) {
    $this->input = $input;
    $this->output = $output;
    $this->io = $io;

    $overwrite = $this->cliCommands->askToOverwritePluginFiles($this);

    if ($overwrite) {
      $this->cliCommands->overwritePluginFiles($this, $overwrite);
    }
  }

  /**
   * Set messages to display to the user at various steps of the installation.
   *
   * @param string $root
   *   The Drupal root.
   *
   * @return $this
   */
  protected function setMessages($root) {
    $messages_file = $root . '/modules/contrib/ckeditor_media_embed/console/translations/en/ckeditor_media_embed.install.yml';
    $messages = Yaml::decode(file_get_contents($messages_file))['messages'];

    $this->messages = array_map(function ($message) {
      return dt($message);
    }, $messages);

    return $this;
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
    return $this->messages[$message_key];
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
   *   The user answer
   */
  public function confirmation($question, $default = FALSE) {
    return $this->io->confirm($question, $default);
  }

  /**
   * Output message in comment style.
   *
   * @param string $text
   *   The comment message.
   */
  public function comment($text) {
    $this->io->text(sprintf('<comment>%s</comment>', $text));
  }

}
