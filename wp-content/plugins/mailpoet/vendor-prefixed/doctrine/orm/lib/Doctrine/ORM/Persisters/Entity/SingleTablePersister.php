<?php
declare (strict_types=1);
namespace MailPoetVendor\Doctrine\ORM\Persisters\Entity;
if (!defined('ABSPATH')) exit;
use MailPoetVendor\Doctrine\Common\Collections\Criteria;
use MailPoetVendor\Doctrine\ORM\Internal\SQLResultCasing;
use MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata;
use MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper;
use function array_flip;
use function implode;
class SingleTablePersister extends AbstractEntityInheritancePersister
{
 use SQLResultCasing;
 protected function getDiscriminatorColumnTableName()
 {
 return $this->class->getTableName();
 }
 protected function getSelectColumnsSQL()
 {
 if ($this->currentPersisterContext->selectColumnListSql !== null) {
 return $this->currentPersisterContext->selectColumnListSql;
 }
 $columnList[] = parent::getSelectColumnsSQL();
 $rootClass = $this->em->getClassMetadata($this->class->rootEntityName);
 $tableAlias = $this->getSQLTableAlias($rootClass->name);
 // Append discriminator column
 $discrColumn = $this->class->getDiscriminatorColumn();
 $discrColumnName = $discrColumn['name'];
 $discrColumnType = $discrColumn['type'];
 $columnList[] = $tableAlias . '.' . $discrColumnName;
 $resultColumnName = $this->getSQLResultCasing($this->platform, $discrColumnName);
 $this->currentPersisterContext->rsm->setDiscriminatorColumn('r', $resultColumnName);
 $this->currentPersisterContext->rsm->addMetaResult('r', $resultColumnName, $discrColumnName, \false, $discrColumnType);
 // Append subclass columns
 foreach ($this->class->subClasses as $subClassName) {
 $subClass = $this->em->getClassMetadata($subClassName);
 // Regular columns
 foreach ($subClass->fieldMappings as $fieldName => $mapping) {
 if (isset($mapping['inherited'])) {
 continue;
 }
 $columnList[] = $this->getSelectColumnSQL($fieldName, $subClass);
 }
 // Foreign key columns
 foreach ($subClass->associationMappings as $assoc) {
 if (!$assoc['isOwningSide'] || !($assoc['type'] & ClassMetadata::TO_ONE) || isset($assoc['inherited'])) {
 continue;
 }
 $targetClass = $this->em->getClassMetadata($assoc['targetEntity']);
 foreach ($assoc['joinColumns'] as $joinColumn) {
 $columnList[] = $this->getSelectJoinColumnSQL($tableAlias, $joinColumn['name'], $this->quoteStrategy->getJoinColumnName($joinColumn, $subClass, $this->platform), PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $targetClass, $this->em));
 }
 }
 }
 $this->currentPersisterContext->selectColumnListSql = implode(', ', $columnList);
 return $this->currentPersisterContext->selectColumnListSql;
 }
 protected function getInsertColumnList()
 {
 $columns = parent::getInsertColumnList();
 // Add discriminator column to the INSERT SQL
 $columns[] = $this->class->getDiscriminatorColumn()['name'];
 return $columns;
 }
 protected function getSQLTableAlias($className, $assocName = '')
 {
 return parent::getSQLTableAlias($this->class->rootEntityName, $assocName);
 }
 protected function getSelectConditionSQL(array $criteria, $assoc = null)
 {
 $conditionSql = parent::getSelectConditionSQL($criteria, $assoc);
 if ($conditionSql) {
 $conditionSql .= ' AND ';
 }
 return $conditionSql . $this->getSelectConditionDiscriminatorValueSQL();
 }
 protected function getSelectConditionCriteriaSQL(Criteria $criteria)
 {
 $conditionSql = parent::getSelectConditionCriteriaSQL($criteria);
 if ($conditionSql) {
 $conditionSql .= ' AND ';
 }
 return $conditionSql . $this->getSelectConditionDiscriminatorValueSQL();
 }
 protected function getSelectConditionDiscriminatorValueSQL()
 {
 $values = [];
 if ($this->class->discriminatorValue !== null) {
 // discriminators can be 0
 $values[] = $this->conn->quote($this->class->discriminatorValue);
 }
 $discrValues = array_flip($this->class->discriminatorMap);
 foreach ($this->class->subClasses as $subclassName) {
 $values[] = $this->conn->quote($discrValues[$subclassName]);
 }
 $discColumnName = $this->class->getDiscriminatorColumn()['name'];
 $values = implode(', ', $values);
 $tableAlias = $this->getSQLTableAlias($this->class->name);
 return $tableAlias . '.' . $discColumnName . ' IN (' . $values . ')';
 }
 protected function generateFilterConditionSQL(ClassMetadata $targetEntity, $targetTableAlias)
 {
 // Ensure that the filters are applied to the root entity of the inheritance tree
 $targetEntity = $this->em->getClassMetadata($targetEntity->rootEntityName);
 // we don't care about the $targetTableAlias, in a STI there is only one table.
 return parent::generateFilterConditionSQL($targetEntity, $targetTableAlias);
 }
}
