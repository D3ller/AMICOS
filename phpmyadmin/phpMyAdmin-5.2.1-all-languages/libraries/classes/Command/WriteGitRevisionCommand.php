<?php

declare(strict_types=1);

namespace PhpMyAdmin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function file_put_contents;
use function is_string;
use function shell_exec;
use function sprintf;
use function str_replace;
use function trim;

class WriteGitRevisionCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'write-revision-info';

    /** @var string */
    private static $generatedClassTemplate = <<<'PHP'
<?php

declare(strict_types=1);

/**
 * This file is generated by scripts/console.
 *
 * @see \PhpMyAdmin\Command\WriteGitRevisionCommand
 */
return [
    'revision' => '%s',
    'revisionUrl' => '%s',
    'branch' => '%s',
    'branchUrl' => '%s',
];

PHP;

    protected function configure(): void
    {
        $this->setDescription('Write Git revision');
        $this->addOption(
            'remote-commit-url',
            null,
            InputOption::VALUE_OPTIONAL,
            'The remote URL to a commit',
            'https://github.com/phpmyadmin/phpmyadmin/commit/%s'
        );
        $this->addOption(
            'remote-branch-url',
            null,
            InputOption::VALUE_OPTIONAL,
            'The remote URL to a branch',
            'https://github.com/phpmyadmin/phpmyadmin/tree/%s'
        );
        $this->setHelp('This command generates the revision-info.php file from Git data.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $commitUrlFormat */
        $commitUrlFormat = $input->getOption('remote-commit-url');
        /** @var string $branchUrlFormat */
        $branchUrlFormat = $input->getOption('remote-branch-url');

        $generatedClass = $this->getRevisionInfo($commitUrlFormat, $branchUrlFormat);
        if ($generatedClass === null) {
            $output->writeln('No revision information detected.');

            return Command::SUCCESS;
        }

        if (! $this->writeGeneratedFile($generatedClass)) {
            return Command::FAILURE;
        }

        $output->writeln('revision-info.php successfully generated!');

        return Command::SUCCESS;
    }

    private function getRevisionInfo(string $commitUrlFormat, string $branchUrlFormat): ?string
    {
        $revisionText = $this->gitCli('describe --always');
        if ($revisionText === null) {
            return null;
        }

        $commitHash = $this->gitCli('log -1 --format="%H"');
        if ($commitHash === null) {
            return null;
        }

        $branchName = $this->gitCli('symbolic-ref -q HEAD') ?? $this->gitCli('name-rev --name-only HEAD 2>/dev/null');
        if ($branchName === null) {
            return null;
        }

        $branchName = trim(str_replace('refs/heads/', '', $branchName));

        return sprintf(
            self::$generatedClassTemplate,
            trim($revisionText),
            sprintf($commitUrlFormat, trim($commitHash)),
            trim($branchName),
            sprintf($branchUrlFormat, $branchName)
        );
    }

    protected function gitCli(string $command): ?string
    {
        /** @psalm-suppress ForbiddenCode */
        $output = shell_exec('git ' . $command);

        return is_string($output) ? $output : null;
    }

    private function writeGeneratedFile(string $generatedClass): bool
    {
        $result = file_put_contents(ROOT_PATH . 'revision-info.php', $generatedClass);

        return $result !== false;
    }
}
