# Condition Operators

Currently is available that operators:

| Name | Description | Parameter |
|------| ------------ | ----------- |
| equals | Check if value are equal. | string / integer / number / boolean |
| = | Check if value are equal. | string / integer / number / boolean |
| starts | Check if a string contains a prefix. | string |
| notStarts | Check if a string not contains a prefix. | string |
| notStartsAny | Check if a string not contains a prefixes. | array of strings |
| has | Check if an array contains some value. | string / integer / number / boolean |
| ends | Check if a string contains a suffix. | string |
| notEnds | Check if a string not contains a suffix. | string |
| gte | Check if a number is greater than or less than. | integer / number |
| &gt;= | Check if a number is greater than or less than. | integer / number |
| lte | Check number is equal to or less than. | integer / number |
| &lt;= | Check number is equal to or less than. | integer / number |
| countMin | Check the minimum number of elements in a field. | integer |
| countMax | Check the maximum number of elements in a field. | integer |
| lengthMin | Check the minimum string length. | integer |
| lengthMax | Check the maximum string length. | integer |
| contains | Check if a string contains a substring. | string |
| notEquals | Check if value are not equal. | string / integer / number / boolean |
| != | Check if value are not equal. | string / integer / number / boolean |
| notHas | Check if an array not contains some value. | string / integer / number / boolean |
| equalsAny | Check if the field is equal to one of the values. | array of strings |
| hasAny | Check if an array contains some value of list. | array of strings |
| notHasAny | Check if an array not contains values of list. | array of strings |
| countEquals | Check count equals. | integer |
| countNotEquals | Check count not equals. | integer |
| countEqualsAny | Check count equals. | array of integers |
| match | Check if a string match a regex. | string |
| isEmpty | Check if a value is empty. | boolean |
| isCamelCase | Check if a string is camelCase. | boolean |
| isStudlyCase | Check if a string is StudlyCase. | boolean |
| isLowerCase | Check if a string is lower case. | boolean |
| isUpperCase | Check if a string is upper case. | boolean |
| isSnakeCase | Check if a string is snake_case. | boolean |
| isKebabCase | Check if a string is kebab-case. | boolean |
| $all | True if all values of array matched conditions. | array |
| $any | True if any value of array matched conditions. | array |
| linesMax | Check the maximum string lines. | integer |
| containsLine | Check if a string contains a line. | string |
| containsHeading1 | Check if a markdown-string contains a heading. | string |
| containsHeading2 | Check if a markdown-string contains a heading. | string |
| containsHeading3 | Check if a markdown-string contains a heading. | string |
| containsHeading4 | Check if a markdown-string contains a heading. | string |
| containsHeading5 | Check if a markdown-string contains a heading. | string |
| containsHeading6 | Check if a markdown-string contains a heading. | string |
| notIntersect | Check that the array does not intersect with the user array. | array of strings |
| isNumber | Check if value are number. | boolean |
| containsNumber | Check if value are contains number. | boolean |

